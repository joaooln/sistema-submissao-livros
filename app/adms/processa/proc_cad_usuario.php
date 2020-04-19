<?php

if (!isset($seg)) {
    exit;
}
$SendCadUser = filter_input(INPUT_POST, 'SendCadUser', FILTER_SANITIZE_STRING);
if (!empty($SendCadUser)) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //Retirar campo da validação vazio
    //var_dump($dados);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    include_once 'lib/lib_email.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar o usuário!</div>";
    } elseif (!validarEmail($dados_validos['email'])) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>E-mail inválido!</div>";
    }
    //validar senha
    elseif ((strlen($dados_validos['senha'])) < 8) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>A senha deve ter no mínimo 8 caracteres!</div>";
    } elseif (stristr($dados_validos['senha'], "'")) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Caracter ( ' ) utilizado na senha inválido!</div>";
    } else {
        //Proibir cadastro de e-mail duplicado
        $result_user_email = "SELECT id FROM adms_usuarios WHERE email='" . $dados_validos['email'] . "'";
        $resultado_user_email = mysqli_query($conn, $result_user_email);
        if (($resultado_user_email) AND ( $resultado_user_email->num_rows != 0 )) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Este e-mail já está cadastrado!</div>";
        }
    }

    //Criar as variaveis da foto quando a mesma não está sendo cadastrada
    if (empty($_FILES['imagem']['name'])) {
        $campo_foto = ",";
        $valor_foto = "";
    }
    //validar extensão da imagem
    else {
        $foto = $_FILES['imagem'];
        include_once 'lib/lib_val_img_ext.php';
        if (!validarExtensao($foto['type'])) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Extensão da foto inválida!</div>";
        } else {
            include_once 'lib/lib_caracter_esp.php';
            $foto['name'] = caracterEspecial($foto['name']);
            $campo_foto = "imagem,";
            $valor_foto = "'" . $foto['name'] . "',";
        }
    }


    //Houve erro em algum campo será redirecionado para o formulário, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/cadastrar/cad_usuario';
        header("Location: $url_destino");
    } else {
        //Criptografar a senha
        $dados_validos['senha'] = password_hash($dados_validos['senha'], PASSWORD_DEFAULT);

        $result_cad_user = "INSERT INTO adms_usuarios (nome, email, senha, adms_niveis_acesso_id, adms_sits_usuario_id, created) VALUES (
        '" . $dados_validos['nome'] . "',
        '" . $dados_validos['email'] . "',
        '" . $dados_validos['senha'] . "',
        $valor_foto
        '" . $dados_validos['adms_niveis_acesso_id'] . "',
        '" . $dados_validos['adms_sits_usuario_id'] . "',
        NOW())";

        echo $result_cad_user;

        mysqli_query($conn, $result_cad_user);
        if (mysqli_insert_id($conn)) {
            unset($_SESSION['dados']);
            //var_dump($_FILES['imagem']);
            //Redimensionar a imagem e fazer upload
            if (!empty($foto['name'])) {
                include_once 'lib/lib_upload.php';
                $destino = "assets/imagens/usuario/" . mysqli_insert_id($conn) . "/";
                upload($foto, $destino, 200, 200);
            }

            $_SESSION['msg'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
            $url_destino = pg . '/listar/list_usuario';
            header("Location: $url_destino");
        } else {
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O usuário não foi cadastrado com sucesso!</div>";
            $url_destino = pg . '/cadastrar/cad_usuario';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
