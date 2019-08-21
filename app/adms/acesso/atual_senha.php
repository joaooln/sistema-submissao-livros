<?php
if (!isset($seg)) {
    exit;
}

$chave = filter_input(INPUT_GET, 'chave', FILTER_SANITIZE_STRING);
if (!empty($chave)) {
    //Pesquisar o usuário
    $result_user_atu = "SELECT id FROM adms_usuarios WHERE recuperar_senha='$chave' LIMIT 1";
    $resultado_user_atu = mysqli_query($conn, $result_user_atu);
    if (($resultado_user_atu) AND ( $resultado_user_atu->num_rows != 0)) {
        $row_user_atu = mysqli_fetch_assoc($resultado_user_atu);
    } else {
        $_SESSION['msgrec'] = "<div class='alert alert-danger'>Link inválido - tente recuperar novamente a senha!</div>";
        $url_destino = pg . "/acesso/recuper_login";
        header("Location: $url_destino");
    }
}

$SendAtuSenha = filter_input(INPUT_POST, 'SendAtuSenha', FILTER_SANITIZE_STRING);
if ($SendAtuSenha) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar o usuário!</div>";
    }//validar senha
    elseif ((strlen($dados_validos['senha'])) < 6) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>A senha deve ter no mínimo 6 caracteres!</div>";
    } elseif (stristr($dados_validos['senha'], "'")) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Caracter ( ' ) utilizado na senha inválido!</div>";
    }

    if (!$erro) {
        //Criptografar a senha
        $dados_validos['senha'] = password_hash($dados_validos['senha'], PASSWORD_DEFAULT);
        $result_user_up = "UPDATE adms_usuarios SET
                senha='" . $dados_validos['senha'] . "',
                recuperar_senha = NULL,
                modified=NOW() 
                WHERE id='" . $dados_validos['id'] . "'";

        mysqli_query($conn, $result_user_up);
        
        if (mysqli_affected_rows($conn)) {
            $_SESSION['msgcad'] = "<div class='alert alert-success'>Senha alterar com sucesso!</div>";
            $url_destino = pg . "/acesso/login";
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao alterar a senha!</div>";
        }
    }
}

include_once 'app/adms/include/head_login.php';
?>
<body class="text-center">
    <form class="form-signin" method="POST" action="">
        <h1 class="h3 mb-3 font-weight-normal">Atualizar de Senha</h1>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>  

        <input type="hidden" name="id" value="<?php
        if (isset($row_user_atu['id'])) {
            echo $row_user_atu['id'];
        }
        ?>">
        <div class="form-group">
            <label>Senha</label>
            <input name="senha" type="password" class="form-control" placeholder="Digite a nova senha com 6 caracteres" required>               
        </div>

        <input type="submit" class="btn btn-lg btn-success btn-block" value="Atualizar" name="SendAtuSenha">
        <p class="text-center">
            Lembrou? <a href="<?php echo pg . '/acesso/login'; ?>">Clique aqui </a>para logar.
        </p>
        <?php
        unset($_SESSION['dados']);
        ?>
    </form>
</body>
