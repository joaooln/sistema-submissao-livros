<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
        //Pesquisar os dados da tabela adms_nivacs_pgs
        $result_niv_ac_pg = "SELECT id, ordem, adms_niveis_acesso_id
                FROM adms_nivacs_pgs
                WHERE id='$id' LIMIT 1";
    } else {
        //Pesquisar os dados da tabela adms_nivacs_pgs
        $result_niv_ac_pg = "SELECT nivacpg.id, nivacpg.ordem, nivacpg.adms_niveis_acesso_id
                FROM adms_nivacs_pgs nivacpg
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=nivacpg.adms_niveis_acesso_id
                WHERE nivacpg.id='$id' AND nivac.ordem > '" . $_SESSION['ordem'] . "' LIMIT 1";
    }
    $resultado_niv_ac_pg = mysqli_query($conn, $result_niv_ac_pg);

    //Retornou algum valor do banco de dados e acesso o IF, senão acessa o ELSe
    if (($resultado_niv_ac_pg) AND ( $resultado_niv_ac_pg->num_rows != 0)) {
        $row_niv_ac_pg = mysqli_fetch_assoc($resultado_niv_ac_pg);
        //Pesquisar o ID do adms_nivacs_pgs a ser movido para baixo
        $ordem_num_menor = $row_niv_ac_pg['ordem'] - 1;
        $result_niv_num_men = "SELECT id, ordem FROM adms_nivacs_pgs 
            WHERE ordem='$ordem_num_menor' AND adms_niveis_acesso_id ='" . $row_niv_ac_pg['adms_niveis_acesso_id'] . "' LIMIT 1";
        $resultado_niv_num_men = mysqli_query($conn, $result_niv_num_men);
        $row_niv_num_men = mysqli_fetch_assoc($resultado_niv_num_men);
        //var_dump($row_niv_num_men);
        //Alterar a ordem do número menor para o número maior
        $result_ins_num_maior = "UPDATE adms_nivacs_pgs SET
                ordem='" . $row_niv_ac_pg['ordem'] . "', 
                modified=NOW()
                WHERE id='" . $row_niv_num_men['id'] . "'";
        $resultado_ins_num_maior = mysqli_query($conn, $result_ins_num_maior);

        //Alterar a ordem do número maior para o número menor
        $result_ins_num_menor = "UPDATE adms_nivacs_pgs SET
                ordem='$ordem_num_menor',
                modified=NOW() 
                WHERE id='" . $row_niv_ac_pg['id'] . "'";
        $resultado_ins_num_menor = mysqli_query($conn, $result_ins_num_menor);

        //Redirecionar conforme a situação do alterar: sucesso ou erro
        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Ordem do menu editado com sucesso!</div>";
            $url_destino = pg . '/listar/list_permissao?id='.$row_niv_ac_pg['adms_niveis_acesso_id'];
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A ordem do menu não foi alterada com sucesso!</div>";
            $url_destino = pg . '/listar/list_permissao?id='.$row_niv_ac_pg['adms_niveis_acesso_id'];
            header("Location: $url_destino");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
        $url_destino = pg . '/listar/list_niv_aces';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/listar/list_niv_aces';
    header("Location: $url_destino");
}
