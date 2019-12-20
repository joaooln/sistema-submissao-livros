<?php

if (!isset($seg)) {
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    $result_checkout_artigo = "SELECT artigo.id id_artigo, user.*, user.id id_user
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

        if ($row_checkout_artigo['normas'] == 1) {
            $descricao = "PUBLICAÇÃO DE ARTIGO CIENTIFICO FORMATADO PELO AUTOR";
            $valor = 300.00;
        } else {
            $descricao = "PUBLICAÇÃO DE ARTIGO CIENTIFICO, COM FORMATAÇÃO";
            $valor = 350.00;
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