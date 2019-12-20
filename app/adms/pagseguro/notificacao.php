<?php

session_start();
ob_start();
$seg = true;
include_once '/config/config.php';
include_once '/config/conexao.php';
include_once '/lib/lib_valida.php';
include_once '/lib/lib_permissao.php';

header("access-control-allow-origin: https://pagseguro.uol.com.br");
header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
require_once("PagSeguro.class.php");

if (isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction') {
    $PagSeguro = new PagSeguro();
    $response = $PagSeguro->executeNotification($_POST);
    if ($response->status == 3 || $response->status == 4) {
        //PAGAMENTO CONFIRMADO
        //ATUALIZAR O STATUS NO BANCO DE DADOS
        $result_artigo_pag_not = "UPDATE adms_artigos SET
                adms_sit_artigo_id=3,
                modified=NOW()
                WHERE id='" . $response->reference . "'";
        $resultado_artigo_pag_not = mysqli_query($conn, $result_artigo_pag_not);

        //echo $PagSeguro->getStatusText($PagSeguro->status);
    } else {
        //PAGAMENTO PENDENTE
        //echo $PagSeguro->getStatusText($PagSeguro->status);
    }
}
?>