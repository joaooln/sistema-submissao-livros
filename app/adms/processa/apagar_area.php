<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    //Apagar o menu
    $result_area_del = "DELETE FROM adms_areas WHERE id='$id'";
    mysqli_query($conn, $result_area_del);
    if (mysqli_affected_rows($conn)) {
        $_SESSION['msg'] = "<div class='alert alert-success'>Área apagada com sucesso!</div>";
        $url_destino = pg . '/listar/list_area';
        header("Location: $url_destino");
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A área não foi apagada!</div>";
        $url_destino = pg . '/listar/lis_area';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

