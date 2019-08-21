<?php
if (!isset($seg)) {
    exit;
}
$SendRecLog = filter_input(INPUT_POST, 'SendRecLog', FILTER_SANITIZE_STRING);
if (!empty($SendRecLog)) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $_SESSION['dados'] = $dados;
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    include_once 'lib/lib_email.php';
    include_once 'lib/lib_env_email.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para recuperar a senha!</div>";
    } elseif (!validarEmail($dados_validos['email'])) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>E-mail inválido!</div>";
    }

    if (!$erro) {
        //Pesquisar o usuário
        $result_user_recup = "SELECT id, nome, email, usuario, recuperar_senha FROM adms_usuarios WHERE email='" . $dados_validos['email'] . "' LIMIT 1";
        $resultado_user_recup = mysqli_query($conn, $result_user_recup);
        if (($resultado_user_recup) AND ( $resultado_user_recup->num_rows != 0)) {
            $row_user_recup = mysqli_fetch_assoc($resultado_user_recup);
            if ($row_user_recup['recuperar_senha'] == "") {
                $recuperar_senha = md5($row_user_recup['id'] . $row_user_recup['email'] . date("Y-m-d H:i:s"));
                $result_up_user_recup = "UPDATE adms_usuarios SET
                        recuperar_senha= '$recuperar_senha',
                        modified= NOW()
                        WHERE id = '" . $row_user_recup['id'] . "'";
                mysqli_query($conn, $result_up_user_recup);
                $row_user_recup['recuperar_senha'] = $recuperar_senha;
            }
            $nome = explode(" ", $row_user_recup['nome']);
            $prim_nome = $nome[0];

            $url = pg . "/acesso/atual_senha?chave=" . $row_user_recup['recuperar_senha'];
            $assunto = "Recuperar senha";

            $mensagem = "Olá " . $prim_nome . "<br><br>";
            $mensagem .= "Você solicitou uma alteração de senha em SS Editora.<br>";
            $mensagem .= "Seguindo o link abaixo você poderá alterar sua senha.<br>";
            $mensagem .= "Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço abaixo no seu navegador.<br><br>";
            $mensagem .= $url . "<br><br>";
            $mensagem .= "Usuário: {$row_user_recup['usuario']}<br><br>";
            $mensagem .= "Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.<br><br>";
            $mensagem .= "Respeitosamente, SS Editora<br>";
            $mensagem_texo = $mensagem;

            if (email_phpmailer($assunto, $mensagem, $mensagem_texto, $prim_nome, $row_user_recup['email'], $conn)) {
                $_SESSION['msgcad'] = "<div class='alert alert-success'>E-mail enviado com sucesso, verifique sua caixa de entrada!</div>";
                $url_destino = pg . '/acesso/login';
                header("Location: $url_destino");
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: ao enviar o e-mail!</div>";
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: e-mail não cadastrado!</div>";
        }
    }
}

include_once 'app/adms/include/head_login.php';
?>
<body class="text-center">
    <form class="form-signin" method="POST" action="">
        <h1 class="h3 mb-3 font-weight-normal">Recuperação de Senha</h1>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="form-group">
            <label>E-mail</label>
            <input name="email" type="email" class="form-control" placeholder="E-mail de cadastro" required value="<?php
            if (isset($_SESSION['dados']['email'])) {
                echo $_SESSION['dados']['email'];
            }
            ?>">               
        </div>

        <input type="submit" class="btn btn-lg btn-success btn-block" value="Recuperar" name="SendRecLog">
        <p class="text-center">
            Lembrou? <a href="<?php echo pg . '/acesso/login'; ?>">Clique aqui </a>para logar.
        </p>
        <?php
        unset($_SESSION['dados']);
        ?>
    </form>
</body>
