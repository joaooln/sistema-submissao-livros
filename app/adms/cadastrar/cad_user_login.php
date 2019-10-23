<?php
if (!isset($seg)) {
    exit;
}
$SendCadLogin = filter_input(INPUT_POST, 'SendCadLogin', FILTER_SANITIZE_STRING);
if (!empty($SendCadLogin)) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //Retirar campo da validação vazio
    $dados_complemento = $dados['complemento'];
    unset($dados['complemento']);
    $_SESSION['dados'] = $dados;

    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    include_once 'lib/lib_email.php';
    include_once 'lib/lib_env_email.php';
    include_once 'lib/lib_valida_cpf.php';
    //var_dump($dados);
    $dados_validos = vazio($dados);
    //var_dump($dados_validos);
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

        //Validar usuário
        //}elseif (stristr($dados_validos['usuario'], "'")) {
        //$erro = true;
        //$_SESSION['msg'] = "<div class='alert alert-danger'>Caracter ( ' ) utilizado no usuário inválido!</div>";
        //} elseif ((strlen($dados_validos['usuario'])) < 5) {
        //$erro = true;
        //$_SESSION['msg'] = "<div class='alert alert-danger'>O usuário deve ter no mínimo 5 caracteres!</div>";
    } else {
        //Proibir cadastro de e-mail duplicado
        $result_user_email = "SELECT id FROM adms_usuarios WHERE email='" . $dados_validos['email'] . "'";
        $resultado_user_email = mysqli_query($conn, $result_user_email);
        if (($resultado_user_email) AND ( $resultado_user_email->num_rows != 0 )) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Este e-mail já está cadastrado!</div>";
        }

        //Proibir cadastro de CPF duplicado
        $result_cpf_dupli = "SELECT id FROM adms_usuarios WHERE cpf='" . $dados_validos['cpf'] . "'";
        $resultado_cpf_dupli = mysqli_query($conn, $result_cpf_dupli);
        if (($resultado_cpf_dupli) AND ( $resultado_cpf_dupli->num_rows != 0 )) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Este CPF já está cadastrado!</div>";
        }
        //Verificar senhas coinciedem
        $senha1 = "$dados_validos[senha]";
        $senha2 = "$dados_validos[senha_conf]";
        if (strcmp($senha1, $senha2) != 0) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>As senhas não coincidem!</div>";
        }
        //Verificar CPF é válido
        if (!validaCPF($dados_validos['cpf'])) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>CPF inválido!</div>";
        }
    }

    if (!$erro) {
        $dados['complemento'] = $dados_complemento;
        //Criptografar a senha
        $dados_validos['senha'] = password_hash($dados_validos['senha'], PASSWORD_DEFAULT);
        $conf_email = md5($dados_validos['senha'] . date('Y-m-d H:i'));

        //Pesquisar qual nível de acesso e situação deve ser atribuido para o usuário
        $result_user_perm = "SELECT * FROM adms_cads_usuarios LIMIT 1";
        $resultado_user_perm = mysqli_query($conn, $result_user_perm);
        $row_user_perm = mysqli_fetch_assoc($resultado_user_perm);

        $result_cad_user = "INSERT INTO adms_usuarios (nome, cpf, telefone, email, senha, rua, num_end, complemento, bairro, cidade, estado, cep, pais ,conf_email, adms_niveis_acesso_id, adms_sits_usuario_id, created) VALUES (
        '" . $dados_validos['nome'] . "',
        '" . $dados_validos['cpf'] . "',
        '" . $dados_validos['telefone'] . "',
        '" . $dados_validos['email'] . "',
        '" . $dados_validos['senha'] . "',
        '" . $dados_validos['rua'] . "',
        '" . $dados_validos['num_end'] . "',
        '" . $dados_complemento . "',
        '" . $dados_validos['bairro'] . "',
        '" . $dados_validos['cidade'] . "',
        '" . $dados_validos['estado'] . "',
        '" . $dados_validos['cep'] . "',
        '" . $dados_validos['pais'] . "',
        '$conf_email',
        '" . $row_user_perm['adms_niveis_acesso_id'] . "',
        '" . $row_user_perm['adms_sits_usuario_id'] . "',
        NOW())";
        echo $result_cad_user;
        mysqli_query($conn, $result_cad_user);
        if (mysqli_insert_id($conn)) {

            if ($row_user_perm['env_email_conf'] == 1) {
                $nome = explode(" ", $dados_validos['nome']);
                $prim_nome = $nome[0];

                $assunto = "Confirmar e-mail";

                $mensagem = "Caro(a) $prim_nome ,<br><br>";
                $mensagem .= "Obrigado por se cadastrar conosco. Para ativar seu perfil, clique no link abaixo:<br><br>";
                $mensagem .= "<a href='" . pg . "/acesso/valida_email?chave=$conf_email'>Clique aqui</a><br><br>";
                $mensagem .= "Obrigado<br>";

                $mensagem_texo = "Caro(a) $prim_nome ,";
                $mensagem_texo .= "Obrigado por se cadastrar conosco. Para ativar seu perfil, copie o endereço abaixo e cole no navegador:";
                $mensagem_texo .= pg . "/acesso/valida_email?chave=$conf_email'";
                $mensagem_texo .= "Obrigado";

                if (email_phpmailer($assunto, $mensagem, $mensagem_texo, $prim_nome, $dados_validos['email'], $conn)) {
                    $_SESSION['msgcad'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso! Acesse o seu e-mail para confirmar o cadastro</div>";
                } else {
                    $_SESSION['msgcad'] = "<div class='alert alert-danger'>Usuário cadastrado com sucesso! Erro ao enviar o e-mail de confirmação</div>";
                }
            } else {
                $_SESSION['msgcad'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
            }
            unset($_SESSION['dados']);
            $url_destino = pg . '/acesso/login';
            header("Location: $url_destino");
        } else {
            $dados['complemento'] = $dados_complemento;
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O usuário não foi cadastrado com sucesso!</div>";
            //$url_destino = pg . '/cadastrar/cad_user_login';
            //header("Location: $url_destino");
        }
    }
}

include_once 'app/adms/include/head.php';
?>
<body>
    <div class="content p-1">
        <div class="list-group-item">
            <div class="d-flex justify-content-center bd-highlight">
                <form method="POST" action="">
                    <div class="mr-auto p-2">
                        <h2 class="display-4 titulo">Novo Cadastro</h2>
                    </div>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label><span class="text-danger">*</span> Nome</label>
                            <input name="nome" type="text" class="form-control" placeholder="Nome completo" required value="<?php
                            if (isset($_SESSION['dados']['nome'])) {
                                echo $_SESSION['dados']['nome'];
                            }
                            ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label><span class="text-danger">*</span> CPF</label>
                            <input name="cpf" type="text" class="form-control cpf" placeholder="CPF" required value="<?php
                            if (isset($_SESSION['dados']['cpf'])) {
                                echo $_SESSION['dados']['cpf'];
                            }
                            ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label><span class="text-danger">*</span> Telefone</label>
                            <input name="telefone" type="text" class="form-control phone_with_ddd" placeholder="Telefone com DDD" required value="<?php
                            if (isset($_SESSION['dados']['telefone'])) {
                                echo $_SESSION['dados']['telefone'];
                            }
                            ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label><span class="text-danger">*</span> E-mail</label>
                            <input name="email" type="text" class="form-control" placeholder="Informe seu e-mail" required value="<?php
                            if (isset($_SESSION['dados']['email'])) {
                                echo $_SESSION['dados']['email'];
                            }
                            ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Senha</label>
                            <input name="senha" type="password" class="form-control" placeholder="Mínimo 8 caracteres" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Confirmar Senha</label>
                            <input name="senha_conf" type="password" class="form-control" placeholder="Informe novamente a senha" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label><span class="text-danger">*</span> Endereço</label>
                            <input name="rua" type="text" class="form-control" placeholder="Rua" required value="<?php
                            if (isset($_SESSION['dados']['rua'])) {
                                echo $_SESSION['dados']['rua'];
                            }
                            ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input name="num_end" type="text" class="form-control cep" placeholder="Número" required value="<?php
                            if (isset($_SESSION['dados']['num_end'])) {
                                echo $_SESSION['dados']['num_end'];
                            }
                            ?>">
                        </div>

                        <div class="form-group col-md-6">
                            <input name="complemento" type="text" class="form-control" placeholder="Complemento" value="<?php
                            if (isset($_SESSION['dados']['complemento'])) {
                                echo $_SESSION['dados']['complemento'];
                            }
                            ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input name="bairro" type="text" class="form-control" placeholder="Bairro" required value="<?php
                            if (isset($_SESSION['dados']['bairro'])) {
                                echo $_SESSION['dados']['bairro'];
                            }
                            ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input name="cidade" type="text" class="form-control" placeholder="Cidade" required value="<?php
                            if (isset($_SESSION['dados']['cidade'])) {
                                echo $_SESSION['dados']['cidade'];
                            }
                            ?>">
                        </div>

                        <div class="form-group col-md-6">
                            <select name="estado" class="custom-select" required>
                                <option selected>Estado</option>
                                <?php
                                $estados = array(
                                    'AC' => 'Acre',
                                    'AL' => 'Alagoas',
                                    'AP' => 'Amapá',
                                    'AM' => 'Amazonas',
                                    'BA' => 'Bahia',
                                    'CE' => 'Ceará',
                                    'DF' => 'Distrito Federal',
                                    'ES' => 'Espirito Santo',
                                    'GO' => 'Goiás',
                                    'MA' => 'Maranhão',
                                    'MS' => 'Mato Grosso do Sul',
                                    'MT' => 'Mato Grosso',
                                    'MG' => 'Minas Gerais',
                                    'PA' => 'Pará',
                                    'PB' => 'Paraíba',
                                    'PR' => 'Paraná',
                                    'PE' => 'Pernambuco',
                                    'PI' => 'Piauí',
                                    'RJ' => 'Rio de Janeiro',
                                    'RN' => 'Rio Grande do Norte',
                                    'RS' => 'Rio Grande do Sul',
                                    'RO' => 'Rondônia',
                                    'RR' => 'Roraima',
                                    'SC' => 'Santa Catarina',
                                    'SP' => 'São Paulo',
                                    'SE' => 'Sergipe',
                                    'TO' => 'Tocantins',
                                );

                                foreach ($estados as $sigla_estado => $nome_estado) {
                                    if (isset($_SESSION['dados']['estado']) AND ( $_SESSION['dados']['estado'] == $sigla_estado)) {
                                        echo " <option value=" . $sigla_estado . ">" . $nome_estado . "</option>";
                                    } else {
                                        echo " <option value=" . $sigla_estado . ">" . $nome_estado . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <input name="cep" type="text" class="form-control cep" placeholder="CEP" required value="<?php
                            if (isset($_SESSION['dados']['cep'])) {
                                echo $_SESSION['dados']['cep'];
                            }
                            ?>">
                        </div>

                        <div class="form-group col-md-6">
                            <input name="pais" type="text" class="form-control" placeholder="País" required value="<?php
                            if (isset($_SESSION['dados']['pais'])) {
                                echo $_SESSION['dados']['pais'];
                            }
                            ?>">
                        </div>
                    </div>



                    <hr class="mb-4">

                    <input type="submit" class="btn btn-lg btn-success btn-block" value="Cadastrar" name="SendCadLogin">
                    <p class="text-center">
                        Lembrou? <a href="<?php echo pg . '/acesso/login'; ?>">Clique aqui </a>para logar.
                    </p>
                    <?php
                    unset($_SESSION['dados']);
                    ?>
                </form>
            </div>
        </div>
    </div>
    <?php
    include_once 'app/adms/include/rodape_lib.php';
    ?>
</body>