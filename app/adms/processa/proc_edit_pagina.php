<?php

if (!isset($seg)) {
    exit;
}
$SendEditPg = filter_input(INPUT_POST, 'SendEditPg', FILTER_SANITIZE_STRING);
if ($SendEditPg) {
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
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para editar a página!</div>";
    } else {
        //Proibir cadastro de página duplicado
        $result_paginas = "SELECT id FROM adms_paginas WHERE endereco='" . $dados_validos['endereco'] . "' AND adms_tps_pg_id='" . $dados_validos['adms_tps_pg_id'] . "' AND id<>'" . $dados['id'] . "' ";
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
        $url_destino = pg . '/editar/edit_pagina?id=' . $dados['id'];
        header("Location: $url_destino");
    } else {
        $result_pg_up = "UPDATE adms_paginas SET
                nome_pagina='" . $dados_validos['nome_pagina'] . "', 
                endereco='" . $dados_validos['endereco'] . "', 
                obs='" . $dados_obs . "', 
                keywords='" . $dados_validos['keywords'] . "', 
                description='" . $dados_validos['description'] . "', 
                author='" . $dados_validos['author'] . "', 
                lib_pub='" . $dados_validos['lib_pub'] . "', 
                icone='" . $dados_icone . "', 
                depend_pg='" . $dados_validos['depend_pg'] . "', 
                adms_grps_pg_id='" . $dados_validos['adms_grps_pg_id'] . "', 
                adms_tps_pg_id='" . $dados_validos['adms_tps_pg_id'] . "', 
                adms_robot_id='" . $dados_validos['adms_robot_id'] . "', 
                adms_sits_pg_id='" . $dados_validos['adms_sits_pg_id'] . "',
                modified=NOW() 
                WHERE id='" . $dados_validos['id'] . "'";

        mysqli_query($conn, $result_pg_up);

        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);
            $_SESSION['msg'] = "<div class='alert alert-success'>Página editada!</div>";
            $url_destino = pg . '/listar/list_pagina';
            header("Location: $url_destino");
        } else {
            $dados['obs'] = trim($dados_obs);
            $dados['icone'] = $dados_icone;
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Página não editada!</div>";
            $url_destino = pg . '/editar/edit_pagina?id=' . $dados['id'];
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
