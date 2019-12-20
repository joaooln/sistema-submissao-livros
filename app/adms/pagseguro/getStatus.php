<?php

require_once("PagSeguro.class.php");

if (isset($_GET['reference'])) {
    $PagSeguro = new PagSeguro();
    $P = $PagSeguro->getStatusByReference($_GET['reference']);
    echo $PagSeguro->getStatusText($P->status);
    $O = $PagSeguro->getTransactionByReference($_GET['reference']);

    $response = $PagSeguro->executeNotification('A5B849B90C6A0C6A6DAAA42D1FB117531B75');
    
    echo $response;
    
    echo $O->reference;
    echo "<br>";
    echo $O->code;
} else {
    echo "Parâmetro \"reference\" não informado!";
}
?>