<?php

session_start();
ob_start();
$seg = true;
$url_host = filter_input(INPUT_SERVER, 'HTTP_HOST');
define('pg', "http://$url_host/sistema-submissao-livros");

$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "ssl";

//Criar a conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);


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