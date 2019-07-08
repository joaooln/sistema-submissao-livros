<?php
session_start();
ob_start();
$seg = true;
include_once './config/config.php';
include_once './config/conexao.php';
include_once './lib/lib_valida.php';

$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING);
$url_limpa = limparUrl($url);

$result_pg = "SELECT * FROM paginas 
        WHERE endereco='" . $url_limpa . "' AND sits_pg_id=1 LIMIT 1";
$resultado_pg = mysqli_query($conn, $result_pg);
?>
<!doctype html>
<html lang="pt-br">
    <?php
    if (($resultado_pg) AND ( $resultado_pg->num_rows != 0)) {
        $row_pg = mysqli_fetch_assoc($resultado_pg);
        $file = "app/" . $row_pg['tp_pagina'] . "/" . $row_pg['endereco'] . ".php";
        if (file_exists($file)) {
            include $file;
        } else {
            include 'app/adms/visualizar/home.php';
        }
    } else {
        include 'app/adms/visualizar/home.php';
    }
    ?>
</html>
