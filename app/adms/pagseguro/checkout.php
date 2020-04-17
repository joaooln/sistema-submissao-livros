<?php

if (!isset($seg)) {
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    $result_checkout_artigo = "SELECT artigo.id id_artigo, normas, valor_livro, adms_tp_subms_id, user.*, user.id id_user
                               FROM adms_artigos artigo 
                               INNER JOIN adms_usuarios user ON user.id=artigo.adms_usuario_id
                               WHERE artigo.id='$id' LIMIT 1";

    $resultado_checkout_artigo = mysqli_query($conn, $result_checkout_artigo);

    if (($resultado_checkout_artigo) AND ( $resultado_checkout_artigo->num_rows != 0)) {
        $row_checkout_artigo = mysqli_fetch_assoc($resultado_checkout_artigo);

        header("access-control-allow-origin: https://pagseguro.uol.com.br");
        header("Content-Type: text/html; charset=UTF-8", true);
        date_default_timezone_set('America/Sao_Paulo');

        require_once("PagSeguro.class.php");
        $PagSeguro = new PagSeguro();

        if ($row_checkout_artigo['adms_tp_subms_id'] == 1) {
            if ($row_checkout_artigo['normas'] == 1) {
                $descricao = "PUBLICAÇÃO DE CAPÍTULO DE LIVRO CIENTIFICO FORMATADO PELO AUTOR";
                $valor = 320.00;
            } else {
                $descricao = "PUBLICAÇÃO DE CAPÍTULO DE LIVRO CIENTIFICO, COM FORMATAÇÃO";
                $valor = 450.00;
            }
        } else {
            if ($row_checkout_artigo['normas'] == 1) {
                $descricao = "PUBLICAÇÃO DE LIVRO CIENTIFICO FORMATADO PELO AUTOR";
                $valor = $row_checkout_artigo['valor_livro'];
                //$valor = number_format($row_checkout_artigo['valor_livro']);
            } else {
                $descricao = "PUBLICAÇÃO DE LIVRO CIENTIFICO, COM FORMATAÇÃO";
                $valor = $row_checkout_artigo['valor_livro'];
                //$valor = number_format($row_checkout_artigo['valor_livro']);
            }
        }



        //EFETUAR PAGAMENTO	
        $venda = array("codigo" => $row_checkout_artigo['id_artigo'],
            "valor" => $valor,
            "descricao" => $descricao,
            "nome" => $row_checkout_artigo['nome'],
            "email" => "joaooln@sandbox.pagseguro.com.br",
            "cpf" => $row_checkout_artigo['cpf'],
            "telefone" => $row_checkout_artigo['telefone'],
            "rua" => $row_checkout_artigo['rua'],
            "numero" => $row_checkout_artigo['num_end'],
            "bairro" => $row_checkout_artigo['bairro'],
            "cidade" => $row_checkout_artigo['cidade'],
            "estado" => $row_checkout_artigo['estado'], //2 LETRAS MAIÚSCULAS
            "cep" => $row_checkout_artigo['cep'],
            "codigo_pagseguro" => "");

        $result_artigo_pag_status = "UPDATE adms_artigos SET
                adms_sit_artigo_id=6,
                modified=NOW()
                WHERE id='$id'";
        $resultado_artigo_pag_status = mysqli_query($conn, $result_artigo_pag_status);

        $PagSeguro->executeCheckout($venda, "https://localhost/sistema-submissao-livros/app/adms/listar/list_artigo.php");




        //----------------------------------------------------------------------------
        //RECEBER RETORNO
        if (isset($_GET['transaction_id'])) {
            $pagamento = $PagSeguro->getStatusByReference($_GET[$row_checkout_artigo['id']]);

            $pagamento->codigo_pagseguro = $_GET['transaction_id'];
            if ($pagamento->status == 3 || $pagamento->status == 4) {
                //ATUALIZAR DADOS DA VENDA, COMO DATA DO PAGAMENTO E STATUS DO PAGAMENTO
                $result_artigo_pag_up = "UPDATE adms_artigos SET
                transaction_id='" . $pagamento->codigo_pagseguro . "',
                modified=NOW()
                WHERE id='" . $row_checkout_artigo['id'] . "'";
                $resultado_artigo_pag_up = mysqli_query($conn, $result_artigo_pag_up);
            } else {
                //ATUALIZAR NA BASE DE DADOS
                $result_artigo_pag_up = "UPDATE adms_artigos SET
                transaction_id='" . $pagamento->codigo_pagseguro . "',
                modified=NOW()
                WHERE id='" . $row_checkout_artigo['id'] . "'";
                $resultado_artigo_pag_up = mysqli_query($conn, $result_artigo_pag_up);
            }
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Artigo não encontrado!</div>";
        $url_destino = pg . '/listar/list_artigo';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
?>