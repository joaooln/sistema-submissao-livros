<?php

if (!isset($seg)) {
    exit;
}
$SendEditPerfil = filter_input(INPUT_POST, 'SendEditPerfil', FILTER_SANITIZE_STRING);
if ($SendEditPerfil) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
//var_dump($dados);
//Retirar campo da validação vazio
    $dados_complemento = $dados['complemento'];
    $dados_imagem_antiga = $dados['imagem_antiga'];
    unset($dados['complemento'], $dados['senha'], $dados['imagem_antiga']);

//validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    include_once 'lib/lib_email.php';
    include_once 'lib/lib_valida_cpf.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos obrigatórios (<b>*</b>) para editar o usuário!</div>";
    } elseif (!validarEmail($dados_validos['email'])) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>E-mail inválido!</div>";
        //Validar usuário
        //elseif (stristr($dados_validos['usuario'], "'")) {
        //    $erro = true;
        //    $_SESSION['msg'] = "<div class='alert alert-danger'>Caracter ( ' ) utilizado no usuário inválido!</div>";
        //} elseif ((strlen($dados_validos['usuario'])) < 5) {
        //    $erro = true;
        //    $_SESSION['msg'] = "<div class='alert alert-danger'>O usuário deve ter no mínimo 5 caracteres!</div>";
    } else {
        //Proibir cadastro de e-mail duplicado
        $result_user_email = "SELECT id FROM adms_usuarios WHERE email='" . $dados_validos['email'] . "' AND id<>'" . $_SESSION['id'] . "' ";
        $resultado_user_email = mysqli_query($conn, $result_user_email);
        if (($resultado_user_email) AND ( $resultado_user_email->num_rows != 0 )) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Este e-mail já está cadastrado!</div>";
        }

        //Verificar CPF é válido
        if (!validaCPF($dados_validos['cpf'])) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>CPF inválido!</div>";
        }
        //Proibir cadastro de CPF duplicado
        $result_cpf_dupli = "SELECT id FROM adms_usuarios WHERE cpf='" . $dados_validos['cpf'] . "'";
        $resultado_cpf_dupli = mysqli_query($conn, $result_cpf_dupli);
        if (($resultado_cpf_dupli) AND ( $resultado_cpf_dupli->num_rows != 0 )) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Este CPF já está cadastrado!</div>";
        }
    }

    //validar senha
    if (empty($dados_senha)) {
        $campo_senha = "";
        $valor_senha = "";
    } else {
        if ((strlen($dados_senha)) < 6) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>A senha deve ter no mínimo 6 caracteres!</div>";
        } elseif (stristr($dados_senha, "'")) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Caracter ( ' ) utilizado na senha inválido!</div>";
        } else {
            $senha_cript = password_hash($dados_senha, PASSWORD_DEFAULT);
            $campo_senha = "senha = ";
            $valor_senha = "'" . $senha_cript . "',";
        }
    }

    //Criar campo complemento
    if (empty($dados_complemento)) {
        $campo_complemento = "";
        $valor_complemento = "";
    } else {
        $campo_complemento = "complemento = ";
        $valor_complemento = "'" . $dados_complemento . "',";
    }

    //Validar imagem
    //Criar as variaveis da foto quando a mesma não está sendo cadastrada
    if (empty($_FILES['imagem']['name'])) {
        $campo_foto = "";
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
            $campo_foto = "imagem = ";
            $valor_foto = "'" . $foto['name'] . "',";
        }
    }

    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta editar no banco
    if ($erro) {
        $dados['senha'] = $dados_senha;
        $dados['complemento'] = $dados_complemento;
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/editar/edit_perfil';
        header("Location: $url_destino");
    } else {
        $result_user_up = "UPDATE adms_usuarios SET
                nome='" . $dados_validos['nome'] . "',
                cpf='" . $dados_validos['cpf'] . "',
                telefone='" . $dados_validos['telefone'] . "',
                email='" . $dados_validos['email'] . "',
                $campo_senha $valor_senha                 
                rua='" . $dados_validos['rua'] . "',
                num_end='" . $dados_validos['num_end'] . "',
                $campo_complemento $valor_complemento
                bairro='" . $dados_validos['bairro'] . "',
                cidade='" . $dados_validos['cidade'] . "',
                estado='" . $dados_validos['estado'] . "',
                cep='" . $dados_validos['cep'] . "',  
                pais='" . $dados_validos['pais'] . "',  
                $campo_foto $valor_foto
                modified=NOW() 
                WHERE id='" . $_SESSION['id'] . "'";

        mysqli_query($conn, $result_user_up);

        if (mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);
            //Redimensionar a imagem e fazer upload
            if (!empty($foto['name'])) {
                include_once 'lib/lib_upload.php';
                $destino = "assets/imagens/usuario/" . $_SESSION['id'] . "/";
                $destino_apagar = $destino . $dados_imagem_antiga;
                apagarFoto($destino_apagar);
                upload($foto, $destino, 150, 150);
            }
            $_SESSION['msg'] = "<div class='alert alert-success'>Perfil editado com sucesso!</div>";
            $url_destino = pg . '/visualizar/vis_perfil';
            header("Location: $url_destino");
        } else {
            $dados['senha'] = $dados_senha;
            $dados['complemento'] = $dados_complemento;
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: perfil não foi editado!</div>";
            $url_destino = pg . '/editar/editar/edit_perfil';
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
