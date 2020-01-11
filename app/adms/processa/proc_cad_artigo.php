<?php

if (!isset($seg)) {
    exit;
}
$SendCadArtigo = filter_input(INPUT_POST, 'SendCadArtigo', FILTER_SANITIZE_STRING);
if (!empty($SendCadArtigo)) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    //var_dump($dados);
    //Retirar campo da validação vazio
    $dados_nomeCoautor = $dados['nomeCoautor'];
    unset($dados['nomeCoautor']);
    $dados_cpfCoautor = $dados['cpfCoautor'];
    unset($dados['cpfCoautor']);

    $dados_cpf_nota = $dados['cpf_nota'];
    unset($dados['cpf_nota']);
    $dados_cnpj_nota = $dados['cnpj_nota'];
    unset($dados['cnpj_nota']);
    $dados_nome_nota_pf = $dados['nome_nota_pf'];
    unset($dados['nome_nota_pf']);
    $dados_email_nota_pf = $dados['email_nota_pf'];
    unset($dados['email_nota_pf']);
    $dados_nome_nota_pj = $dados['nome_nota_pj'];
    unset($dados['nome_nota_pj']);
    $dados_email_nota_pj = $dados['email_nota_pj'];
    unset($dados['email_nota_pj']);
    if (empty($dados_nome_nota_pf)) {
        $dados_nome_nota = $dados_nome_nota_pj;
    } else {
        $dados_nome_nota = $dados_nome_nota_pf;
    }
    if (empty($dados_email_nota_pf)) {
        $dados_email_nota = $dados_email_nota_pj;
    } else {
        $dados_email_nota = $dados_email_nota_pf;
    }

    //Grava dados nome e cpf coautores para vetor
    for ($index = 4; $index > 0; $index--) {
        if (empty($dados_nomeCoautor[$index])) {
            $dados_nomeCoautor[$index] = "";
        }
        if (empty($dados_cpfCoautor[$index])) {
            $dados_cpfCoautor[$index] = "";
        }
    }

    // Array com as extensões permitidas
    $_UP['extensoes'] = array('doc', 'docx');

    // Array com os tipos de erros de upload do PHP
    $_UP['erros'][0] = 'Não houve erro';
    $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
    $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
    $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
    $_UP['erros'][4] = 'Não foi feito o upload do arquivo';

    // Tamanho máximo do arquivo (em Bytes)
    $_UP['tamanho'] = 1024 * 1024 * 5; // 5Mb
    // Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
    $_UP['renomeia'] = true;

    //Remove caractes especiais
    include_once 'lib/lib_caracter_esp.php';
    include_once 'lib/lib_email.php';
    include_once 'lib/lib_env_email.php';
    $arquivo['name'] = caracterEspecial($_FILES['arquivo']['name']);
    $extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));

    //var_dump($dados);
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    var_dump($dados_validos);
    //if (!$dados_validos) {
    //$erro = true;
    // $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para cadastrar o artigo!</div>";
    // }
    // Faz a verificação da extensão do arquivo
    if (array_search($extensao, $_UP['extensoes']) == false) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Por favor, envie arquivos com as seguintes extensões: doc ou docx</div>";
    }

    // Faz a verificação do tamanho do arquivo
    if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>O arquivo enviado é muito grande, envie arquivos de até 5Mb.</div>";
    }

    //echo "Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro";
    if ($_FILES['arquivo']['error'] != 0) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Não foi possível fazer o upload. Verifique se o arquivo é menor que 5 MB.</div>";
    }

    //Houve erro em algum campo será redirecionado para o formulário, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $dados['nomeCoautor'] = $dados_nomeCoautor;
        $dados['cpfCoautor'] = $dados_cpfCoautor;
        $_SESSION['dados'] = $dados;
        $url_destino = pg . '/cadastrar/cad_artigo';
        header("Location: $url_destino");
    } else {

        $valor_arquivo = "'" . $dados_validos['tituloArtigo'] . "." . $extensao . "',";
        $nome_final = $dados_validos['tituloArtigo'] . "." . $extensao;

        $result_cad_artigo = "INSERT INTO adms_artigos (tituloLivro, tituloArtigo, nomeCoautor1, cpfCoautor1, nomeCoautor2, cpfCoautor2, nomeCoautor3, cpfCoautor3, nomeCoautor4, cpfCoautor4,
      nomeCoautor5, cpfCoautor5, normas, nota_outro_nome, nome_nota, cpf_nota, cnpj_nota, email_nota, arquivo, adms_sit_artigo_id ,adms_usuario_id, created) VALUES (
      '" . $dados_validos['tituloLivro'] . "',
      '" . $dados_validos['tituloArtigo'] . "',
      '" . $dados_nomeCoautor[0] . "',
      '" . $dados_cpfCoautor[0] . "',
      '" . $dados_nomeCoautor[1] . "',
      '" . $dados_cpfCoautor[1] . "',
      '" . $dados_nomeCoautor[2] . "',
      '" . $dados_cpfCoautor[2] . "',
      '" . $dados_nomeCoautor[3] . "',
      '" . $dados_cpfCoautor[3] . "',
      '" . $dados_nomeCoautor[4] . "',
      '" . $dados_cpfCoautor[4] . "',
      '" . $dados_validos['normas'] . "',
      '" . $dados_validos['nota_outro_nome'] . "',
      '" . $dados_nome_nota . "',
      '" . $dados_cpf_nota . "',
      '" . $dados_cnpj_nota . "',
      '" . $dados_email_nota . "',    
      $valor_arquivo
      '" . 1 . "',
      '" . $_SESSION['id'] . "',
      NOW())";
        mysqli_query($conn, $result_cad_artigo);
        if (mysqli_insert_id($conn) and $erro == false) {
            //Fazer upload
            //echo "Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar";
            // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
            //Pasta onde o arquivo vai ser salvo
            $_UP['pasta'] = "assets/artigosRecebidos/" . mysqli_insert_id($conn) . "/";

            //Cria pasta
            mkdir($_UP['pasta'], 0755);
            // Depois verifica se é possível mover o arquivo para a pasta escolhida
            if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
                //echo "Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo";
                //echo '<br /><a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
            } else {
                //echo $nome_final;
                //$_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Falha no Upload!</div>";
                //$url_destino = pg . '/listar/list_artigo';
                header("Location: $url_destino");
                // Não foi possível fazer o upload, provavelmente a pasta está incorreta
            }

            //$_SESSION['msg'] = "<div class='alert alert-success'>Artigo cadastrado com sucesso!</div>";
            //$url_destino = pg . '/listar/list_artigo';
            //header("Location: $url_destino");

            $result_user = "SELECT user.*
            FROM adms_usuarios user
            WHERE user.id=" . $_SESSION['id'] . " LIMIT 1";

            $resultado_user = mysqli_query($conn, $result_user);
            if (($resultado_user) AND ( $resultado_user->num_rows != 0)) {
                $row_user = mysqli_fetch_assoc($resultado_user);
            }

            $nome = explode(" ", $row_user['nome']);
            $prim_nome = $nome[0];

            $assunto = "Confirmação de Recebimento";

            $mensagem = "Caro(a) $prim_nome,<br><br>";
            $mensagem .= "Confirmamos o recebimento do seu trabalho conforme especificações abaixo:<br><br>";
            $mensagem .= "Titulo do Artigo: '" . $dados_validos['tituloArtigo'] . "'<br>";
            $mensagem .= "Titulo do Livro: '" . $dados_validos['tituloLivro'] . "'<br>";
            $mensagem .= "Coautores: <br>";
            for ($index = 0; $index < 4; $index++) {
                if ($dados_nomeCoautor[$index] != "") {
                    $mensagem .= "Nome: '" . $dados_nomeCoautor[$index] . "' - CPF: '" . dados_cpfCoautor[$index] . "'<br>";
                }
            }
            $mensagem .= "Trabalho está nas Normas?: ";
            if ($dados_validos['normas'] == 1) {
                $normas_texto = "Sim <br>";
            } else {
                $normas_texto = "Não. A empresa irá realizar a normatização <br>";
            }
            $mensagem .= $normas_texto;
            $mensagem .= "Nota Fiscal será emitida em seu nome?: ";
            if ($dados_validos['nota_outro_nome'] == 1) {
                $nota_outro_nome_texto = "Sim <br>";
            } elseif ($dados_validos['nota_outro_nome'] == 2) {
                $nota_outro_nome_texto = "Não. A Nota Fiscal deverá ser no nome de outra pessoa. <br>";
            } else {
                $nota_outro_nome_texto = "Não. A Nota Fiscal deverá ser no nome de uma instituição ou empresa. <br>";
            }
            $mensagem .= $nota_outro_nome_texto;
            if (!empty($dados_nome_nota)) {
                $mensagem .= "Nome para emissão da nota fiscal: '" . $dados_nome_nota . "' - ";
            }
            if (!empty($dados_cpf_nota)) {
                $mensagem .= "CPF: '" . $dados_cpf_nota . "' <br>";
            }
            if (!empty($dados_cnpj_nota)) {
                $mensagem .= "CNPJ: '" . $dados_cnpj_nota . "' <br>";
            }
            $mensagem .= "Data da Submissão: '" . date('d/m/y') . "'<br>";
            $mensagem .= "Situação: Em Avaliação <br>";
            $mensagem .= "Arquivo: ";
            $mensagem .= "<a href = '" . pg . "/" . $_UP['pasta'] . "" . $nome_final . "'>" . $nome_final . "</a><br><br>";
            $mensagem .= "Em breve entraremos em contato para dar continuidade aos termos editoriais.<br><br>";
            $mensagem .= "At.te<br>Prof. Dr. Dionatas Meneguetti";

            echo $mensagem;

            $mensagem_texto = "Caro(a) $prim_nome ,<br><br>";
            $mensagem_texto .= "Confirmamos o recebimento do seu trabalho conforme especificações abaixo:<br><br>";
            $mensagem_texto .= "Titulo do Artigo: " . $dados_validos['tituloArtigo'] . "<br>";
            $mensagem_texto .= "Titulo do Livro: " . $dados_validos['tituloLivro'] . "<br>";
            $mensagem_texto .= "Coautores: <br>";
            for ($index = 0; $index < 4; $index++) {
                if (!empty($dados['nomeCoautor'][$index])) {
                    $mensagem .= "Nome: '" . $dados_nomeCoautor[$index] . "' - CPF: '" . dados_cpfCoautor[$index] . "'<br>";
                }
            }
            $mensagem_texto .= "Data da Submissão: '" . date('d/m/y') . "'<br>";
            $mensagem_texto .= "Situação: Em Avaliação <br>";
            $mensagem_texto .= "Em breve entraremos em contato para dar continuidade aos termos editoriais.<br><br>";
            $mensagem_texto .= "At.te<br>Prof. Dr. Dionatas Meneguetti";

            /* if (email_phpmailer($assunto, $mensagem, $mensagem_texto, $prim_nome, $row_user['email'], $conn)) {
              echo "Email Enviado";
              //$_SESSION['msgcad'] = "<div class='alert alert-success'>Email Enviado</div>";
              } else {
              echo "Erro";
              //$_SESSION['msgcad'] = "<div class='alert alert-danger'>Erro ao enviar o email</div>";
              }
             * 
             */
        } else {
            $erro = true;
            //$dados['apelido'] = $dados_apelido;
            $_SESSION['dados'] = $dados;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O artigo não foi cadastrado com sucesso!</div>";
            $url_destino = pg . '/cadastrar/cad_artigo';
            $_SESSION['dados'] = $dados;
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
    
