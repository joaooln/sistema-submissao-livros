<?php

if (!isset($seg)) {
    exit;
}
$SendCadPg = filter_input(INPUT_POST, 'SendCadPg', FILTER_SANITIZE_STRING);
if ($SendCadPg) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //Retirar campo da validação vazio
    $dados_obs = $dados['obs'];
    $dados_icone = $dados['icone'];
    unset($dados['obs'], $dados['icone']);
    //var_dump($dados);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar a página!</div>";
    } else {
        //Proibir cadastro de página duplicado
        $result_paginas = "SELECT id FROM adms_paginas WHERE endereco='" . $dados_validos['endereco'] . "' AND adms_tps_pg_id='" . $dados_validos['adms_tps_pg_id'] . "'";
        $resultado_paginas = mysqli_query($conn, $result_paginas);
        if (($resultado_paginas) AND ( $resultado_paginas->num_rows != 0 )) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Este endereço já está cadastrado!</div>";
        }
    }

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $dados['obs'] = trim($dados_obs);
        $dados['icone'] = $dados_icone;
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/cadastrar/cad_pagina';
        header("Location: $url_destino");
    } else {
        $result_cad_pg = "INSERT INTO adms_paginas (nome_pagina, endereco, obs, keywords, description, author, lib_pub, icone, depend_pg, adms_grps_pg_id, adms_tps_pg_id, adms_robot_id, adms_sits_pg_id, created) VALUES (
        '" . $dados_validos['nome_pagina'] . "',
        '" . $dados_validos['endereco'] . "',
        '$dados_obs',
        '" . $dados_validos['keywords'] . "',
        '" . $dados_validos['description'] . "',
        '" . $dados_validos['author'] . "',
        '" . $dados_validos['lib_pub'] . "',
        '$dados_icone',
        '" . $dados_validos['depend_pg'] . "',
        '" . $dados_validos['adms_grps_pg_id'] . "',
        '" . $dados_validos['adms_tps_pg_id'] . "',
        '" . $dados_validos['adms_robot_id'] . "',                
        '" . $dados_validos['adms_sits_pg_id'] . "',
        NOW())";

        mysqli_query($conn, $result_cad_pg);
        if (mysqli_insert_id($conn)) {
            unset($_SESSION['dados']);
            //Inicio inserir na tabela adms_nivacs_pgs
            $pagina_id = mysqli_insert_id($conn);

            //Pesquisar os niveis de acesso
            $result_niv_acesso = "SELECT id, nome FROM adms_niveis_acessos";
            $resultado_niv_acesso = mysqli_query($conn, $result_niv_acesso);
            while ($row_niv_acesso = mysqli_fetch_assoc($resultado_niv_acesso)) {
                //Determinar 1 na permissao caso seja superadministrador e para outros niveis 2: 1 = Liberado, 2 - Bloqueado
                if ($row_niv_acesso['id'] == 1) {
                    $permissao = 1;
                } else {
                    $permissao = 2;
                }

                //Pesquisar o maior número da ordem na tabela adms_nivacs_pgs para o nível em execução
                $result_maior_ordem = "SELECT ordem FROM adms_nivacs_pgs WHERE adms_niveis_acesso_id='" . $row_niv_acesso['id'] . "' ORDER BY ordem DESC LIMIT 1";
                $resultado_maior_ordem = mysqli_query($conn, $result_maior_ordem);
                $row_maior_ordem = mysqli_fetch_assoc($resultado_maior_ordem);
                $ordem = $row_maior_ordem['ordem'] + 1;

                //Cadastrar no banco de dados a permissão de acessar a página na tabela adms_nivacs_pgs
                $result_cad_pagina = "INSERT INTO adms_nivacs_pgs (permissao, ordem, dropdown, lib_menu, adms_menu_id, adms_niveis_acesso_id, adms_pagina_id, created) VALUES (
                    '$permissao',
                    '$ordem',
                    '1',
                    '2',
                    '3',
                    '" . $row_niv_acesso['id'] . "',
                    '$pagina_id',
                    NOW())";

                mysqli_query($conn, $result_cad_pagina);
            }

            $_SESSION['msg'] = "<div class='alert alert-success'>Página cadastrada!</div>";
            $url_destino = pg . '/listar/list_pagina';
            header("Location: $url_destino");
        } else {
            $dados['obs'] = trim($dados_obs);
            $dados['icone'] = $dados_icone;
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Página não cadastrada!</div>";
            $url_destino = pg . '/cadastrar/cad_pagina';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
