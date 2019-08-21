<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    //Verificar se há adms_nivacs_pgs usando menu
    $result_niv_ac_ver = "SELECT id FROM adms_nivacs_pgs WHERE adms_menu_id='$id' LIMIT 1";
    $resultado_niv_ac_ver = mysqli_query($conn, $result_niv_ac_ver);
    if (($resultado_niv_ac_ver) AND ( $resultado_niv_ac_ver->num_rows != 0)) {
        $_SESSION['msg'] = "<div class='alert alert-danger'>O menu não pode ser apagado. Há níveis de acesso cadastrados neste menu!</div>";
        $url_destino = pg . '/listar/list_menu';
        header("Location: $url_destino");
    } else {//Não há nenhum nível de acesso cadastro nesse menu
        //Pesquisar no banco de dados se há menu com ordem acima do qual será apagado
        $result_men_ver = "SELECT id, ordem AS ordem_result FROM adms_menus WHERE ordem > (SELECT ordem FROM adms_menus WHERE id='$id') ORDER BY ordem ASC";
        $resultado_men_ver = mysqli_query($conn, $result_men_ver);

        //Apagar o menu
        $result_men_del = "DELETE FROM adms_menus WHERE id='$id' AND ordem > '" . $_SESSION['ordem'] . "'";
        mysqli_query($conn, $result_men_del);
        if (mysqli_affected_rows($conn)) {

            //Alterar a sequencia da ordem para não deixar nenhum número da ordem vazio
            if (($resultado_men_ver) AND ( $resultado_men_ver->num_rows != 0)) {
                while ($row_men = mysqli_fetch_assoc($resultado_men_ver)) {
                    $row_men['ordem_result'] = $row_men['ordem_result'] - 1;
                    $result_men_or = "UPDATE adms_menus SET
                   ordem='" . $row_men['ordem_result'] . "', 
                   modified=NOW()
                   WHERE id='" . $row_men['id'] . "'";
                    mysqli_query($conn, $result_men_or);
                }
            }
            $_SESSION['msg'] = "<div class='alert alert-success'>Menu apagado com sucesso!</div>";
            $url_destino = pg . '/listar/list_menu';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O menu não foi apagado!</div>";
            $url_destino = pg . '/listar/lis_menu';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

