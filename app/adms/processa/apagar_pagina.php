<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    //Apagar a página
    $result_pg_del = "DELETE FROM adms_paginas WHERE id='$id'";
    mysqli_query($conn, $result_pg_del);
    if (mysqli_affected_rows($conn)) {
        //Apagar as permissões de acesso a página na tabela adms_nivacs_pgs
        $result_nivacs_del = "DELETE FROM adms_nivacs_pgs WHERE adms_pagina_id='$id'";
        mysqli_query($conn, $result_nivacs_del);
        $_SESSION['msg'] = "<div class='alert alert-success'>Página apagada com sucesso!</div>";
        $url_destino = pg . '/listar/list_pagina';
        header("Location: $url_destino");
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>A Página não apagada!</div>";
        $url_destino = pg . '/listar/list_pagina';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

