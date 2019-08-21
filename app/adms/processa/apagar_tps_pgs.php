<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    //Verificar se há página cadastra no tipo de página
    $result_pg_val = "SELECT id FROM adms_paginas WHERE adms_tps_pg_id='$id' LIMIT 1";
    $resultado_pg_val = mysqli_query($conn, $result_pg_val);
    if (($resultado_pg_val) AND ( $resultado_pg_val->num_rows != 0)) {
        $_SESSION['msg'] = "<div class='alert alert-danger'>O tipo de página não pode ser apagado, há páginas cadastradas neste tipo de página!</div>";
        $url_destino = pg . '/listar/list_tps_pgs';
        header("Location: $url_destino");
    } else {//Não há nenhuma página cadastra neste tipo de página
        //Pesquisar no banco de dados se há tipo de página com ordem acima do qual será apagado
        $result_tps_pgs = "SELECT id, ordem AS ordem_result FROM adms_tps_pgs WHERE ordem > (SELECT ordem FROM adms_tps_pgs WHERE id='$id') ORDER BY ordem ASC";
        $resultado_tps_pgs = mysqli_query($conn, $result_tps_pgs);

        //Apagar o tipo de pagina
        $result_tps_pgs_del = "DELETE FROM adms_tps_pgs WHERE id='$id'";
        mysqli_query($conn, $result_tps_pgs_del);
        if (mysqli_affected_rows($conn)) {

            //Alterar a sequencia da ordem para não deixar nenhum número da ordem vazio
            if (($resultado_tps_pgs) AND ( $resultado_tps_pgs->num_rows != 0)) {
                while ($row_tps_pgs = mysqli_fetch_assoc($resultado_tps_pgs)) {
                    $row_tps_pgs['ordem_result'] = $row_tps_pgs['ordem_result'] - 1;
                    $result_tps_pgs_or = "UPDATE adms_tps_pgs SET
                        ordem='" . $row_tps_pgs['ordem_result'] . "', 
                        modified=NOW()
                        WHERE id='" . $row_tps_pgs['id'] . "'";
                    mysqli_query($conn, $result_tps_pgs_or);
                }
            }
            $_SESSION['msg'] = "<div class='alert alert-success'>Tipo de página apagado com sucesso!</div>";
            $url_destino = pg . '/listar/list_tps_pgs';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O tipo de página não foi apagado!</div>";
            $url_destino = pg . '/listar/list_tps_pgs';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

